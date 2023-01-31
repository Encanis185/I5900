import { StatusBar } from 'expo-status-bar';
import { SafeAreaView } from 'react-native-safe-area-context';
import { StyleSheet, Text, TouchableOpacity, View, Image, TextInput, Button, ScrollView, FlatList} from 'react-native';
import { useEffect, useState } from 'react';

export default function Centers({navigation}) {
    const [DATA, setDATA] = useState();

    useEffect(()=>{
        const extractData = async () => {
            const url = 'https://projectatp.000webhostapp.com/SSPBD/ExtractAllData.php';

            const petition = await fetch(url);
            const response = await petition.json();

            setDATA(response);
        }

        extractData();
    }, []);

    const centerCard = ({item}) => {
        return(
            <TouchableOpacity
                onPress={() => navigation.navigate('CenterInfo', {
                    imagenURL: item.imagenURL,
                    centro: item.nombreCentro,
                    estado: item.nombreEstado,
                    municipio: item.nombreMunicipio,
                    tipoCentro: item.nombreTipoCentro,
                    idCentro: item.idCentro,
                })}
            >
                <View style={styles.cardContainer}>
                    <View style={styles.cardImageContainer}>
                        <Image
                            style={styles.Image}
                            source={{uri: item.imagenURL}}
                        />
                    </View>
                    <View style={styles.cardCiteInfo}>
                        <Text style={{fontSize: 22, fontWeight: '600', color:'#EFF3F5'}}>{item.nombreCentro}</Text>
                        <Text style={{fontSize: 16, marginTop: 5, color: '#C8CDD0'}}>{item.nombreEstado}, {item.nombreMunicipio}</Text>
                        <Text style={{fontSize: 16, marginTop: 5, color: '#C8CDD0'}}>{item.nombreTipoCentro}</Text>
                    </View>
                </View>
            </TouchableOpacity>
        );
    }

    return (
        <SafeAreaView style={styles.mainContainer}>
                <Text style={{fontSize: 20, fontWeight: '600', color: '#EFF3F5', marginVertical: 20}}>Centros</Text>
                <FlatList
                    data = {DATA}
                    keyExtractor = {(item) => item.id}
                    renderItem = {centerCard}
                />
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    mainContainer: {
        flex: 1,
        width: '100%',
        backgroundColor: '#192229',
        justifyContent: 'center',
        alignItems: 'center',
    },

    cardContainer: {
        display: 'flex',
        width: '100%',
        borderRadius: 16,
        backgroundColor: '#2A3B47',
        marginBottom: 30,
    },

    cardImageContainer: {
        width: '100%',
        height: 200,
        borderTopLeftRadius: 16,
        borderTopRightRadius: 16,
        overflow: 'hidden',
        backgroundColor: 'gray',
    },

    Image: {
        width: '100%',
        height: '100%',
        resizeMode: 'stretch',
    },

    cardCiteInfo: {
        padding: 15
    },
});